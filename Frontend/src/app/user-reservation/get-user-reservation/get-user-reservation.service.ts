import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class GetUserReservationService {
  private baseUrl = 'http://localhost:8000/api/reservations';

  constructor(private http: HttpClient) {}

  createReservation(userId: number, date: string, time: string, numOfCustomers: number, reservationType: string): Observable<any> {
    const formattedTime = encodeURIComponent(time);
    const url = `${this.baseUrl}/${userId}/${date}/${formattedTime}/${numOfCustomers}/${reservationType}`;
    console.log(url);
    return this.http.post<any>(url, {});
  }
}
