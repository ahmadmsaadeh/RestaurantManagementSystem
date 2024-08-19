<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ReservationController
{
    /**
     * @OA\Get(
     *     path="/reservations/{id}",
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
    public function getUserReservations($id = null)
    {

    }

    /**
     * @OA\Post(
     *     path="/reservations/{user_id}/{Date}/{time}/{numOfCustomers}/{ReservationType}",
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

    }

    /**
     * @OA\Patch(
     *     path="/reservations/{reservationID}",
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

    }

    /**
     * @OA\Delete(
     *     path="/reservations/{reservationID}",
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

    }

    /**
     * @OA\Get(
     *     path="/reservations/date/{Date}",
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
     *     path="/reservations/date/{Date}/time/{time}",
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
     *     path="/reservations/id/{ReservationID}",
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
     *     path="/staff/reservations",
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
     *     path="/staff/reservations/{user_id}",
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
     *     path="/staff/reservations/date/{Date}",
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
     *     path="/staff/reservations/date/{Date}/time/{time}",
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
}
