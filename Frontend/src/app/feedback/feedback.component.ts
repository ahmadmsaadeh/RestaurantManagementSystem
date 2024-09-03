import { Component, OnInit } from '@angular/core';
import { FeedbackService } from '../services/feedback.service'; 

@Component({
  selector: 'app-feedback',
  templateUrl: './feedback.component.html',
  styleUrls: ['./feedback.component.css']
})
export class FeedbackComponent implements OnInit {
  step: number = 1;
  progress: number = 50; 
  orders: any[] = [];
  selectedOrder: any = null;
  selectedItem: any = null;
  selectedRating: number | null = null;
  feedbackText: string = '';
  userId = 1; 

  ratings = [
    { value: 1, label: 'Very Bad', icon: 'bi-x-circle' },
    { value: 2, label: 'Bad', icon: 'bi-dash-circle' },
    { value: 3, label: 'Neutral', icon: 'bi-circle' },
    { value: 4, label: 'Good', icon: 'bi-check-circle' },
    { value: 5, label: 'Very Good', icon: 'bi-hand-thumbs-up' }
  ];

  constructor(private feedbackService: FeedbackService) {}

  ngOnInit(): void {
    this.loadOrders();
  }

  loadOrders() {
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

  selectOrder(order: any) {
    this.selectedOrder = order;
    this.selectedItem = null; 
    this.step = 2;
  }


  selectItem(item: any) {
    this.selectedItem = item;
    console.log('Selected Item:', this.selectedItem); 
  }

  selectRating(rating: any) {
    this.selectedRating = rating.value;
  }

  submitFeedback() {
    const now = new Date();
    const dateSubmitted = now.toISOString().slice(0, 19).replace('T', ' ');
  
    const feedback = {
      order_id: this.selectedOrder ? this.selectedOrder.order_id : null,
      menu_item_id: this.selectedItem ? this.selectedItem.menu_item_id : null, 
      customer_id: this.userId,
      rating: this.selectedRating,
      comments: this.feedbackText,
      date_submitted: dateSubmitted
    };
  
    console.log('Feedback Object:', feedback);
  
    this.feedbackService.submitFeedback(feedback).subscribe(
      (response: any) => {
        console.log('Feedback submitted:', response);
        this.progress = 100;
        setTimeout(() => {
          this.step = 3; 
        }, 500); 
      },
      (error: any) => {
        console.error('Error submitting feedback:', error);
      }
    );
  }

  goBack() {
    this.step = 1;
  }


  resetForm() {
    this.step = 1;
    this.progress = 50; 
    this.selectedOrder = null;
    this.selectedItem = null;
    this.selectedRating = null;
    this.feedbackText = '';
  }
}
