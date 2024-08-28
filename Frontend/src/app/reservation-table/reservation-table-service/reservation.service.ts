import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ReservationService {
  private apiUrl = 'http://localhost:8000/api/staff/reservations';
  private userApiUrl = 'http://localhost:8000/api/users/';
  private staffDeleteReservation = 'http://localhost:8000/api/staff/reservations/';

  constructor(private http: HttpClient) {}

  getReservations(): Observable<any[]> {
    return this.http.get<any[]>(this.apiUrl);
  }

  getUser(userId: number): Observable<any> {
    return this.http.get<any>(`${this.userApiUrl}${userId}`);
  }

  deleteReservation(reservationId: number): Observable<any> {
    return this.http.delete<any>(`${this.staffDeleteReservation}${reservationId}`);
  }
}
