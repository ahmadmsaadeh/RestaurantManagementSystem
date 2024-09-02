import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import {map, Observable} from 'rxjs';
import { tap } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class ReservationService {
  private apiUrl = 'http://localhost:8000/api/staff/reservations';
  private apiUrlUser = 'http://localhost:8000/api/reservations/';
  private userApiUrl = 'http://localhost:8000/api/users/';
  private staffDeleteReservation = 'http://localhost:8000/api/staff/reservations/';
  private saveToFileUrl = 'http://localhost:8000/api/save-reservations'; // Laravel endpoint to save data

  constructor(private http: HttpClient) {}

  // Fetch reservations from the server and save them to a JSON file
  loadReservationsFromServer(): Observable<any[]> {
    return this.http.get<any[]>(this.apiUrl).pipe(
      tap(reservations => {
        const userRequests = reservations.map(reservation =>
          this.getUser(reservation.UserID).toPromise()
        );
        Promise.all(userRequests).then(userResponses => {
          reservations.forEach((reservation, index) => {
            reservation.username = userResponses[index].username;
          });
          this.saveReservationsToFile(reservations); // Save to JSON file on server
        });
      })
    );
  }

  // Get reservations and save them to a JSON file
  getReservations(): Observable<any[]> {
    return this.http.get<any[]>(this.apiUrl).pipe(
      tap(reservations => {
        this.saveReservationsToFile(reservations); // Save to JSON file on server
      })
    );
  }

  getUserReservations(userId: number): Observable<any[]> {
    const userReservationsUrl = `${this.apiUrlUser}${userId}`;
    return this.http.get<any[]>(userReservationsUrl);
  }

  // Fetch user data
  getUser(userId: number): Observable<any> {
    return this.http.get<any>(`${this.userApiUrl}${userId}`);
  }

  // Delete a reservation and update the JSON file
  deleteReservation(reservationId: number): Observable<any> {
    return this.http.delete<any>(`${this.staffDeleteReservation}${reservationId}`).pipe(
      tap(() => {
        this.loadReservationsFromServer().subscribe();
      })
    );
  }

  // Save reservations data to a JSON file on the server
  private saveReservationsToFile(reservations: any[]): void {
    console.log('Reservations data being sent to the server:', reservations); // Debugging line
    this.http.post(this.saveToFileUrl, { reservations }).subscribe(
      () => console.log('Reservations saved to JSON file'),
      error => {
        console.error('Error saving reservations to JSON file', error);
        alert('Failed to save reservations to the JSON file on the server.');
      }
    );
  }



  getReservationIds(): Observable<number[]> {
    return this.getReservations().pipe(
      map((reservations: any[]) => reservations.map((reservation: any) => reservation.ResID)) // Specify the type of reservation
    );
  }
  getTableIds(): Observable<number[]> {
    return this.getReservations().pipe(
      map((reservations: any[]) => reservations.map((reservation: any) => reservation.TableID)) // Specify the type of reservation
    );
  }
  getUserIDByReservationID(reservationID: number): Observable<number | undefined> {
    return this.getReservations().pipe(
      map((reservations: any[]) => {
        console.log('Fetched reservations:', reservations); // Debugging log
        const reservation = reservations.find(r => r.ResID === Number(reservationID)); // or String(reservationID)
        console.log('Looking for ResID:', reservationID);
        console.log('Found reservation:', reservation); // Debugging log
        if (reservation) {
          console.log('Reservation UserID:', reservation.UserID); // Log UserID if found
        } else {
          console.log('No reservation found with ResID:', reservationID); // Log if not found
        }
        return reservation ? reservation.UserID : undefined;
      })
    );
  }

  getUsername(UserID: any): Observable<string> {
    return (this.http.get<any>(`${this.userApiUrl}${UserID}`)).pipe(
      map( user =>user.username)
    );
  }



}
