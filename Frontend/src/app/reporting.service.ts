import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ReportingService {


  private baseUrl = 'http://localhost:8000/api/reports';  

  constructor(private http: HttpClient) { }

  getMonthlySales(): Observable<any[]> {
    return this.http.get<any[]>(`${this.baseUrl}/sales-monthly`);
  }

  getYearlySales(): Observable<any[]> {
    return this.http.get<any[]>(`${this.baseUrl}/sales-yearly`);
  }

  getMenuItemOrders(): Observable<any[]> {
    return this.http.get<any[]>(`${this.baseUrl}/menu-item-count`);
  }

  getFeedbackAverage(): Observable<any[]> {
    return this.http.get<any[]>(`${this.baseUrl}/feedback-tracking`);
  }
}
