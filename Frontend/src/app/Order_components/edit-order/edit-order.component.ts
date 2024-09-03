import {Component, OnInit} from '@angular/core';
import {OrdersService} from "../../services/orders.service";
import { ActivatedRoute, Router } from '@angular/router';
import {FormsModule} from "@angular/forms";
import {NgForOf, NgIf} from "@angular/common";
@Component({
  selector: 'app-edit-order',
  templateUrl: './edit-order.component.html',
  standalone: true,
  imports: [
    FormsModule,
    NgIf,
    NgForOf
  ],
  styleUrls: ['./edit-order.component.css']
})
export class EditOrderComponent implements OnInit{
  orderId: string | null = null;
  order: any = [];
  orderItems: any[] = [];
  total: number = 0;
  newMenuItemId: number | null = null; // Updated to number and nullable
  newQuantity: number = 1;
  showConfirmation: boolean = false;
  selectedItemId: string = '';
  isEditingStatus: boolean = false;
  selectedStatus: string = '';
  statusOptions: string[] = ['Open', 'Served', 'Closed'];

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private ordersService: OrdersService
  ) {}

  ngOnInit(): void {
    this.route.paramMap.subscribe(params => {
      this.orderId = params.get('id');

      if (this.orderId) {
        this.fetchOrderDetails(this.orderId);
        this.fetchOrderItems(this.orderId);
      }
    });
  }

  fetchOrderDetails(orderId: string): void {
    this.ordersService.getOrderById(orderId).subscribe(
      data => {
        this.order = data;
        this.selectedStatus = this.order.status; // Initialize selectedStatus
      },
      error => {
        alert('Error fetching order details');
      }
    );
  }

  fetchOrderItems(orderId: string): void {
    this.ordersService.getOrderItems(orderId).subscribe(response => {
      this.orderItems = response.Items;
      this.total = response.total;
    });
  }


  calculateTotal(): number {
    return this.orderItems.reduce((sum, item) => sum + item.price * item.quantity, 0);
  }

  editStatus(): void {
    this.isEditingStatus = true;
  }

  saveStatus(): void {
    if (this.orderId) {
      this.ordersService.updateOrderStatus(this.orderId, this.selectedStatus).subscribe(
        () => {
          this.isEditingStatus = false;
          this.order.status = this.selectedStatus; // Update status in the UI
        },
        error => {
          alert('Error updating order status');
        }
      );
    }
  }

  cancelEditStatus(): void {
    this.isEditingStatus = false;
    this.selectedStatus = this.order.status; // Revert to the original status
  }

  addMenuItem(): void {
    if (this.orderId && this.newMenuItemId !== null) {
      const itemData = {
        menu_item_id: this.newMenuItemId,
        quantity: this.newQuantity
      };

      this.ordersService.addMenuItemToOrder(this.orderId, itemData).subscribe(
        () => {
          this.fetchOrderItems(this.orderId!);
          this.newMenuItemId = null; // Reset to null after adding
          this.newQuantity = 1;
        },
        error => {
          alert('Error adding menu item');
        }
      );
    }
  }

  confirmRemoveMenuItem(itemId: string): void {
    this.showConfirmation = true;
    this.selectedItemId = itemId;
  }

  removeMenuItem(itemId: string): void {
    if (this.orderId) {
      this.ordersService.removeMenuItemFromOrder(this.orderId, itemId).subscribe(
        () => {
          this.fetchOrderItems(this.orderId!);
          this.showConfirmation = false;
        },
        error => {
          alert('Error removing menu item');
        }
      );
    }
  }

  cancelConfirmation(): void {
    this.showConfirmation = false;
  }

  cancel(): void {
    this.router.navigate(['/orders']);
  }
}
