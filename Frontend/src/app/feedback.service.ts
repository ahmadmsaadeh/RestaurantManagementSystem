import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class FeedbackService {
  private baseUrl = 'http://localhost:8000/api'; // Update with your Laravel backend URL

  constructor(private http: HttpClient) {}

  // Get orders by user ID
  getOrdersByUserId(userId: number): Observable<any> {
    return this.http.get<any>(`${this.baseUrl}/orders/user/${userId}`);
  }

  // Get order items by order ID
  getOrderItems(orderId: number): Observable<any> {
    return this.http.get<any>(`${this.baseUrl}/orders/${orderId}/items`);
  }

  // Submit feedback
  submitFeedback(feedback: any): Observable<any> {
    return this.http.post<any>(`${this.baseUrl}/feedbacks`, feedback);
  }
}
