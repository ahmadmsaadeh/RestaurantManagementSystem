import {Component, OnInit} from '@angular/core';
import {OrdersService} from "../../services/orders.service";

@Component({
  selector: 'app-items',
  templateUrl: './items.component.html',
  styleUrls: ['./items.component.css']
})
export class ItemsComponent implements OnInit{
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
        alert('Order item status updated successfully:');
      },
      error => {
        console.error('Error updating order item status:', error);
        alert('Error updating order item status: ' + (error.message || 'Unknown error'));
      }
    );
  }

}
