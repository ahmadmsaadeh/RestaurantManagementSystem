import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
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
}
