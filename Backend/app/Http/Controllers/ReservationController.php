<?php

/**
 * @file Routes for handling reservations.
 *
 * @author Ahmad Saadeh
 */

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Reservation",
 *     type="object",
 *     title="Reservation",
 *     required={"UserID", "Date", "Time", "NumOfCustomers", "ReservationType", "TableID", "TimeExpectedToLeave"},
 *
 *     @OA\Property(
 *         property="UserID",
 *         type="integer",
 *         description="The ID of the user making the reservation",
 *         example=1
 *     ),
 *
 *     @OA\Property(
 *         property="Date",
 *         type="string",
 *         format="date",
 *         description="The date of the reservation",
 *         example="18-08-2024"
 *     ),
 *
 *     @OA\Property(
 *         property="Time",
 *         type="string",
 *         format="time",
 *         description="The time of the reservation",
 *         example="18:00:00"
 *     ),
 *
 *     @OA\Property(
 *         property="NumOfCustomers",
 *         type="integer",
 *         description="The number of customers for the reservation",
 *         example=4
 *     ),
 *
 *     @OA\Property(
 *         property="ReservationType",
 *         type="string",
 *         description="The type of reservation (e.g., 'Drinks', 'Food')",
 *         example="dine-in"
 *     ),
 *
 *     @OA\Property(
 *         property="TableID",
 *         type="integer",
 *         description="The ID of the table reserved",
 *         example=10
 *     ),
 *
 *     @OA\Property(
 *         property="TimeExpectedToLeave",
 *         type="string",
 *         format="time",
 *         description="The expected time for the reservation to end",
 *         example="20:00:00"
 *     )
 * )
 */

class ReservationController
{
    /**
     * @OA\Get(
     *     path="/api/reservations/{id}",
     *     tags={"Reservations"},
     *     summary="Get reservations for a specific user",
     *     description="Retrieve all reservations for a user.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reservations retrieved"
     *     )
     * )
     */
    public function getUserReservations($user_id): JsonResponse
    {
        $user = User::find($user_id);
        if (!$user) {
            return response()->json(['error' => 'Invalid user id'], 404);
        }

        $reservations = $user->reservations;
        if ($reservations->isEmpty()) {
            return response()->json(['message' => 'Nothing get'], 404);
        }else{
            return response()->json($reservations, 200);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/reservations/{user_id}/{Date}/{time}/{numOfCustomers}/{ReservationType}",
     *     tags={"Reservations"},
     *     summary="Add a new reservation",
     *     description="Allows users to add a new reservation.",
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="Date",
     *         in="path",
     *         description="Reservation date",
     *         required=true,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="time",
     *         in="path",
     *         description="Reservation time",
     *         required=true,
     *         @OA\Schema(type="string", format="time")
     *     ),
     *     @OA\Parameter(
     *         name="numOfCustomers",
     *         in="path",
     *         description="Number of customers",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="ReservationType",
     *         in="path",
     *         description="Type of reservation",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Reservation added"
     *     )
     * )
     */
    public function addReservation($user_id, $Date, $time, $numOfCustomers, $ReservationType)
    {
        try {
            $time = new \DateTime($time);
            $newTime = clone $time;

            if ($ReservationType === 'Drink') {
                $newTime->add(new \DateInterval('PT1H'));
            } else {
                $newTime->add(new \DateInterval('PT2H'));
            }

            $timeExpectedToLeave = $newTime->format('H:i:s');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        $availableTables = $this->findAvailableTables($time, $ReservationType, $Date);
        $tablesReserved = false;
        $availableChairs = 0;

        foreach ($availableTables as $table) {
            if ($numOfCustomers <= $table->NumberOfChairs) {
                Reservation::create([
                    'UserID' => $user_id,
                    'Date' => $Date,
                    'Time' => $time,
                    'NumOfCustomers' => $numOfCustomers,
                    'ReservationType' => $ReservationType,
                    'TableID' => $table->TableID,
                    'TimeExpectedToLeave' => $timeExpectedToLeave,
                ]);
                $tablesReserved = true;
                break;
            }
            $availableChairs += $table->NumberOfChairs;
        }
        if (!$tablesReserved && $availableChairs >= $numOfCustomers) {
            $largestTable = $availableTables->last();
            $chairsToReserve = $largestTable->NumberOfChairs;
            Reservation::create([
                'UserID' => $user_id,
                'Date' => $Date,
                'Time' => $time,
                'NumOfCustomers' => $chairsToReserve,
                'ReservationType' => $ReservationType,
                'TableID' => $largestTable->TableID,
                'TimeExpectedToLeave' => $timeExpectedToLeave,
            ]);
            $remainingCustomers = $numOfCustomers - $chairsToReserve;
            if ($remainingCustomers > 0) {
                return $this->addReservation($user_id, $Date, $time->format('H:i:s'), $remainingCustomers, $ReservationType);
            }
        } else {
            return response()->json([
                'error' => "No enough tables for this reservation (we can't serve more than $availableChairs customers at this time)"], 400);
        }
        return response()->json(['message' => 'Reservation created successfully'], 201);
    }

    /**
     * @OA\Patch(
     *     path="/api/reservations/{reservationID}",
     *     tags={"Reservations"},
     *     summary="Update a reservation",
     *     description="Allows users to update an existing reservation.",
     *     @OA\Parameter(
     *         name="reservationID",
     *         in="path",
     *         description="Reservation ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Reservation details to update",
     *         @OA\JsonContent(
     *             @OA\Property(property="Date", type="string", format="date"),
     *             @OA\Property(property="time", type="string", format="time"),
     *             @OA\Property(property="numOfCustomers", type="integer"),
     *             @OA\Property(property="ReservationType", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reservation updated"
     *     )
     * )
     */
    public function updateReservation(Request $request, $reservationID)
    {
        $reservation = Reservation::find($reservationID);
        if (!$reservation) {
            return response()->json(['error' => 'Invalid reservation id'], 404);
        }

        $data = $request->all();

        $reservation -> update($data);

        //TODO: When the customer number updated for the reservation delete the reservation and create a new one.
        return response()->json($reservation, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/reservations/{reservationID}",
     *     tags={"Reservations"},
     *     summary="Delete a reservation",
     *     description="Allows users to delete a reservation.",
     *     @OA\Parameter(
     *         name="reservationID",
     *         in="path",
     *         description="Reservation ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reservation deleted"
     *     )
     * )
     */
    public function deleteReservation($reservationID)
    {
        $reservation = Reservation::find($reservationID);
        if (!$reservation) {
            return response()->json(['error' => 'Invalid reservation id'], 404);
        }
        $reservation -> delete();
        return response()->json(null, 204);
    }

    /**
     * @OA\Get(
     *     path="/api/reservations/date/{Date}",
     *     tags={"Reservations"},
     *     summary="Get reservations by date",
     *     description="Retrieve reservations based on the date.",
     *     @OA\Parameter(
     *         name="Date",
     *         in="path",
     *         description="Reservation date",
     *         required=true,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reservations retrieved"
     *     )
     * )
     */
    public function getReservationByDate($Date)
    {

    }

    /**
     * @OA\Get(
     *     path="/api/reservations/date/{Date}/time/{time}",
     *     tags={"Reservations"},
     *     summary="Get reservations by date and time",
     *     description="Retrieve reservations based on the date and time.",
     *     @OA\Parameter(
     *         name="Date",
     *         in="path",
     *         description="Reservation date",
     *         required=true,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="time",
     *         in="path",
     *         description="Reservation time",
     *         required=true,
     *         @OA\Schema(type="string", format="time")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reservations retrieved"
     *     )
     * )
     */
    public function getReservationByTime($Date, $time)
    {

    }

    /**
     * @OA\Get(
     *     path="/api/reservations/id/{ReservationID}",
     *     tags={"Reservations"},
     *     summary="Get reservation by ID",
     *     description="Retrieve a specific reservation by its ID.",
     *     @OA\Parameter(
     *         name="ReservationID",
     *         in="path",
     *         description="Reservation ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reservation retrieved"
     *     )
     * )
     */
    public function getReservationByID($ReservationID)
    {

    }

    /**
     * @OA\Get(
     *     path="/api/staff/reservations",
     *     tags={"Reservations"},
     *     summary="Staff: Get all user reservations",
     *     description="Retrieve all reservations for all users (staff only).",
     *     @OA\Response(
     *         response=200,
     *         description="Reservations retrieved"
     *     )
     * )
     */
    public function getAllUsersReservations()
    {

    }

    /**
     * @OA\Get(
     *     path="/api/staff/reservations/{user_id}",
     *     tags={"Reservations"},
     *     summary="Staff: Get all reservations for a specific user",
     *     description="Retrieve all reservations for a specific user (staff only).",
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reservations retrieved"
     *     )
     * )
     */
    public function getAllReservations($user_id = null)
    {

    }

    /**
     * @OA\Get(
     *     path="/api/staff/reservations/date/{Date}",
     *     tags={"Reservations"},
     *     summary="Staff: Get reservations by date",
     *     description="Retrieve reservations by date (staff only).",
     *     @OA\Parameter(
     *         name="Date",
     *         in="path",
     *         description="Reservation date",
     *         required=true,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reservations retrieved"
     *     )
     * )
     */
    public function getAllReservationByDate($Date)
    {

    }

    /**
     * @OA\Get(
     *     path="/api/staff/reservations/date/{Date}/time/{time}",
     *     tags={"Reservations"},
     *     summary="Staff: Get reservations by date and time",
     *     description="Retrieve reservations by date and time (staff only).",
     *     @OA\Parameter(
     *         name="Date",
     *         in="path",
     *         description="Reservation date",
     *         required=true,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="time",
     *         in="path",
     *         description="Reservation time",
     *         required=true,
     *         @OA\Schema(type="string", format="time")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reservations retrieved"
     *     )
     * )
     */
    public function getAllReservationByTime($Date, $time)
    {

    }

    /**
     * @param $time
     * @param $ReservationType
     * @param $Date
     * @return JsonResponse
     */
    public function findAvailableTables($time, $ReservationType, $Date): JsonResponse
    {
        try {
            $time = new \DateTime($time);
            $newTime = clone $time;

            if ($ReservationType === 'Drink') {
                $newTime->add(new \DateInterval('PT1H'));
            } else {
                $newTime->add(new \DateInterval('PT2H'));
            }

            $timeExpectedToLeave = $newTime->format('H:i:s');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        $availableTables = Table::whereNotIn('TableID', function ($query) use ($Date, $time, $timeExpectedToLeave) {
            $query->select('TableID')
                ->from('reservations')
                ->where('date', $Date)
                ->where(function ($query2) use ($time, $timeExpectedToLeave) {
                    $query2->whereBetween('time', [$time, $timeExpectedToLeave])
                        ->orWhereBetween('TimeExpectedToLeave', [$time, $timeExpectedToLeave])
                        ->orWhere(function ($query3) use ($time, $timeExpectedToLeave) {
                            $query3->where('time', '<=', $time)
                                ->where('TimeExpectedToLeave', '>=', $timeExpectedToLeave);
                        });
                });
        })
            ->orderBy('NumberOfChairs', 'asc')
            ->get();
        return response()->json($availableTables, 200);
    }
}
