import { Component } from '@angular/core';
import {OrdersService} from "../../services/orders.service";

@Component({
  selector: 'app-kitchen-orders',
  templateUrl: './kitchen-orders.component.html',
  styleUrls: ['./kitchen-orders.component.css']
})
export class KitchenOrdersComponent {
  items: any[] = [];
  searchOrderId: string = ''; // Variable to hold the search input

  constructor(private orderItemsService: OrdersService) { }

  ngOnInit(): void {
    // Initially load items with a default status, if needed
    this.filterItems('Pending');
  }

  filterItems(status: string): void {
    this.orderItemsService.getOrderItemsByStatus(status).subscribe(
      data => {
        this.items = data.Items;
      },
      error => {
        console.error('Error fetching order items:', error);
        this.items = [];
      }
    );
  }

  searchItemsByOrderId(): void {
    if (this.searchOrderId.trim()) {
      this.orderItemsService.getOrderItemsByOrderId(this.searchOrderId).subscribe(
        data => {
          this.items = data.Items;
        },
        error => {
          console.error('Error fetching order items:', error);
          this.items = [];
        }
      );
    }
  }

  updateStatus(orderId: string, itemId: string, status: string): void {
    this.orderItemsService.updateOrderItemStatus(orderId, itemId, status).subscribe(
      response => {

        const currentFilterStatus = this.items.length > 0 ? this.items[0].status : 'Pending'; // Assuming all items currently displayed have the same status
        this.filterItems(currentFilterStatus);
        alert('Order item status updated successfully:');
      },
      error => {
        console.error('Error updating order item status:', error);
        alert('Error updating order item status: ' + (error.message || 'Unknown error'));
      }
    );
  }

}
