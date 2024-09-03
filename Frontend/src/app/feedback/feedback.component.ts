import { Component, OnInit } from '@angular/core';
import { FeedbackService } from '../feedback.service'; // Adjust the path as necessary

@Component({
  selector: 'app-feedback',
  templateUrl: './feedback.component.html',
  styleUrls: ['./feedback.component.css']
})
export class FeedbackComponent implements OnInit {
  step: number = 1;
  progress: number = 50; // Initial progress value
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

  // Load orders based on user ID
  loadOrders() {
    this.feedbackService.getOrdersByUserId(this.userId).subscribe(
      (response: any[]) => {
        this.orders = response;
        // Attach items to each order
        this.orders.forEach(order => this.fetchOrderItems(order.order_id));
      },
      (error: any) => {
        console.error('Error loading orders:', error);
      }
    );
  }

  // Fetch order items for a specific order and attach to the order
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

  // Handle order selection
  selectOrder(order: any) {
    this.selectedOrder = order;
    this.selectedItem = null; // Reset selected item
    this.step = 2;
  }

  // Handle item selection
  selectItem(item: any) {
    this.selectedItem = item;
    console.log('Selected Item:', this.selectedItem); // Debugging line
  }

  // Handle rating selection
  selectRating(rating: any) {
    this.selectedRating = rating.value;
  }

  // Submit feedback and handle the submission progress
  submitFeedback() {
    const now = new Date();
    const dateSubmitted = now.toISOString().slice(0, 19).replace('T', ' ');
  
    // Construct the feedback object
    const feedback = {
      order_id: this.selectedOrder ? this.selectedOrder.order_id : null,
      menu_item_id: this.selectedItem ? this.selectedItem.menu_item_id : null, // Ensure this is correctly set
      customer_id: this.userId,
      rating: this.selectedRating,
      comments: this.feedbackText,
      date_submitted: dateSubmitted
    };
  
    console.log('Feedback Object:', feedback); // Debugging line
  
    this.feedbackService.submitFeedback(feedback).subscribe(
      (response: any) => {
        console.log('Feedback submitted:', response);
        // Update progress and change step
        this.progress = 100;
        setTimeout(() => {
          this.step = 3; // Move to thank you step after submission
        }, 500); // Adjust delay as needed
      },
      (error: any) => {
        console.error('Error submitting feedback:', error);
      }
    );
  }

  // Go back to the previous step
  goBack() {
    this.step = 1;
  }

  // Reset form to initial state
  resetForm() {
    this.step = 1;
    this.progress = 50; // Reset progress bar
    this.selectedOrder = null;
    this.selectedItem = null;
    this.selectedRating = null;
    this.feedbackText = '';
  }
}
