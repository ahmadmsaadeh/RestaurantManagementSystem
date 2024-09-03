import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class OrdersService {

  constructor(private http:HttpClient) {

  }

  getOrders():Observable <any>{
    return this.http.get<any>(`http://localhost:8000/api/orders`);
  }
  getOrderById(orderId: string): Observable<any> {
    return this.http.get<any>(`http://localhost:8000/api/orders/${orderId}`);
  }
  getOrderByUserId(userId: string): Observable<any> {
    return this.http.get<any>(`http://localhost:8000/api/orders/user/${userId}`);
  }
  getOrderByReservationId(reservationId: string): Observable<any> {
    return this.http.get<any>(`http://localhost:8000/api/orders/reservation/${reservationId}`);
  }
  getOrdersByStatus(status: string): Observable<any> {
    return this.http.get<any>(`http://localhost:8000/api/orders/status/${status}`);
  }

  getOrdersByDateRange(startDate: string, endDate: string): Observable<any> {
    return this.http.get<any>(`http://localhost:8000/api/orders/date-range/${startDate}/${endDate}`);
  }

  getOrderItems(orderId: string): Observable<any> {
    return this.http.get<any>(`http://localhost:8000/api/orders/${orderId}/items`);
  }
  createOrder(orderData: any): Observable<any> {
    return this.http.post<any>(`http://localhost:8000/api/orders/createOrder`,orderData);
  }
  deleteOrder(orderId: string): Observable<any>{
    return this.http.delete<any>(`http://localhost:8000/api/orders/${orderId}`);

  }

  getOrderItemsByStatus(status: string): Observable<any> {
    return this.http.get<any>(`http://localhost:8000/api/orders/items/status/${status}`);
  }

  getOrderItemsByOrderId(orderId: string): Observable<any> {
    return this.http.get<any>(`http://localhost:8000/api/orders/${orderId}/items`);
  }

  addMenuItemToOrder(orderId: string, itemData: { menu_item_id: number; quantity: number }): Observable<any> {
    return this.http.put<any>(`http://localhost:8000/api/orders/${orderId}/addItem`, itemData);
  }

  removeMenuItemFromOrder(orderId: string, itemId: string): Observable<any> {
    return this.http.delete<any>(`http://localhost:8000/api/orders/${orderId}/items/${itemId}`);
  }
  updateOrderStatus(orderId: string, status: string): Observable<any> {
    return this.http.patch<any>(`http://localhost:8000/api/orders/${orderId}/status`, {status});
  }

  updateOrderItemStatus(orderId: string, itemId: string, status: string): Observable<any> {
    return this.http.patch<any>(`http://localhost:8000/api/orders/${orderId}/items/${itemId}/status`, { status });
  }
}
