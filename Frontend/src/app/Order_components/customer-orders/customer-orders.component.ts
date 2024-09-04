import {Component, OnInit} from '@angular/core';
import {FeedbackService} from "../../services/feedback.service";
import {LoginService} from "../../login/service/LoginService";

@Component({
  selector: 'app-customer-orders',
  templateUrl: './customer-orders.component.html',
  styleUrls: ['./customer-orders.component.css']
})
export class CustomerOrdersComponent implements OnInit{
  step: number = 1;
  progress: number = 50;
  orders: any[] = [];

  userId: number | null = null;

  constructor(
    private feedbackService: FeedbackService,
    private loginService: LoginService
  ) {}

  ngOnInit(): void {
    this.userId = this.loginService.getUserId();
    if (this.userId !== null) {
      this.loadOrders();
    } else {
      console.error('User ID is null. Cannot load orders.');
    }
  }

  loadOrders() {
    if (this.userId !== null) {
      this.feedbackService.getOrdersByUserId(this.userId).subscribe(
        (response: any[]) => {
          this.orders = response;
          this.orders.forEach(order => this.fetchOrderItems(order.order_id));
        },
        (error: any) => {
          console.error('Error loading orders:', error);
        }
      );
    }
  }

  fetchOrderItems(orderId: number) {
    this.feedbackService.getOrderItems(orderId).subscribe(
      (response: any) => {
        const order = this.orders.find(o => o.order_id === orderId);
        if (order) {
          order.items = response.Items || [];
        }
      },
      (error: any) => {
        console.error('Error loading order items:', error);
      }
    );
  }

}
