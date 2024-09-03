import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class FeedbackService {
  private baseUrl = 'http://localhost:8000/api'; 

  constructor(private http: HttpClient) {}


  getOrdersByUserId(userId: number): Observable<any> {
    return this.http.get<any>(`${this.baseUrl}/orders/user/${userId}`);
  }

  getOrderItems(orderId: number): Observable<any> {
    return this.http.get<any>(`${this.baseUrl}/orders/${orderId}/items`);
  }

  submitFeedback(feedback: any): Observable<any> {
    return this.http.post<any>(`${this.baseUrl}/feedbacks`, feedback);
  }
  getItemFeedback(menuItemId: number): Observable<any> {
    return this.http.get<any>(`${this.baseUrl}/feedbacks/item/${menuItemId}`);
  }
  getFeedbacks(): Observable<any[]> {
    return this.http.get<any[]>(`${this.baseUrl}/feedbacks`);
  }
  getFeedbacksByUser(userId: number): Observable<any[]> {
    return this.http.get<any[]>(`${this.baseUrl}/feedbacks/user/${userId}`);
  }


  updateFeedback(id: number, feedback: any): Observable<any> {
    return this.http.put<any>(`${this.baseUrl}/feedbacks/${id}`, feedback);
  }

  deleteFeedback(id: number): Observable<void> {
    return this.http.delete<void>(`${this.baseUrl}/feedbacks/${id}`);
  }
}
