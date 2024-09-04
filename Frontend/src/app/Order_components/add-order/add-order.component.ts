import {Component, OnInit} from '@angular/core';
import {ReservationService} from "../../reservation-table/reservation-table-service/reservation.service";
import {OrdersService} from "../../services/orders.service";

@Component({
  selector: 'app-add-order',
  templateUrl: './add-order.component.html',
  styleUrls: ['./add-order.component.css']
})
export class AddOrderComponent implements OnInit{
  reservationIds: number[] = [];
  tableIds: number[] = [];
  orderItems: any[] = [];

  selectedReservationId: number | null = null;
  selectedTableId: number | null = null;
  fetchedUserId: number | undefined;

  constructor(
    private reservationService: ReservationService,
    private ordersService: OrdersService,
  ) {}

  ngOnInit(): void {
    this.loadReservationIds();
    this.loadTableIds();
  }

  loadReservationIds(): void {
    this.reservationService.getReservationIds().subscribe((ids: number[]) => {
      this.reservationIds = ids;
    }, error => {
      console.error('Error fetching reservation IDs', error);
    });
  }

  loadTableIds(): void {
    this.reservationService.getTableIds().subscribe((tableids: number[]) => {
      this.tableIds = tableids;
    }, error => {
      console.error('Error fetching reservation IDs', error);
    });
  }

  addItemToOrder(item: any): void {
    const existingItem = this.orderItems.find(orderItem => orderItem.menu_item_id === item.menu_item_id);
    if (existingItem) {
      existingItem.quantity += 1;
    } else {
      this.orderItems.push({ ...item, quantity: 1 });
    }
  }


  onQuantityChange(index: number, newValue: number): void {
    const quantity = Number(newValue);
    if (quantity > 0) {
      this.orderItems[index].quantity = quantity;
    } else {
      this.removeItem(index);
    }
  }

  removeItem(index: number): void {
    this.orderItems.splice(index, 1);
  }

  getTotalAmount(): number {
    return this.orderItems.reduce((total, item) => total + (item.price * item.quantity), 0);
  }
  placeOrder(): void {
    if (this.selectedReservationId && this.orderItems.length > 0) {
      this.reservationService.getUserIDByReservationID(this.selectedReservationId).subscribe(userId => {
        if (userId) {
          const orderData = {
            user_id: userId,
            reservation_id: this.selectedReservationId,
            order_items: this.orderItems.map(item => ({
              menu_item_id: item.menu_item_id,
              quantity: item.quantity
            }))
          };

          this.ordersService.createOrder(orderData).subscribe(response => {
            alert('Order placed successfully!');

          }, error => {
            console.error('Error placing order', error);
            alert('Failed to place order.');
          });
        } else {
          console.error('User ID not found for reservation ID:', this.selectedReservationId);
          alert('Failed to retrieve user ID.');
        }
      }, error => {
        console.error('Error fetching user ID', error);
        alert('Failed to retrieve user ID.');
      });
    } else {
      alert('Please provide all necessary details and add at least one item.');
    }
  }



  cancelOrder(): void {
    this.orderItems = []; // Clear the order items
  }



  fetchUserId(): void {
    if (this.selectedReservationId) {
      this.reservationService.getUserIDByReservationID(this.selectedReservationId).subscribe(userId => {
        this.fetchedUserId = userId;
      }, error => {
        console.error('Error fetching user ID', error);
        alert('Failed to retrieve user ID.');
      });
    } else {
      this.fetchedUserId = undefined;
    }
  }

}
