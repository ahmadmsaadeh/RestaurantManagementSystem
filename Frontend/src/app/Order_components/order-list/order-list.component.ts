import {Component, inject, Input, OnInit} from '@angular/core';
import {OrdersService} from "../../services/orders.service";
import {MatSnackBar} from "@angular/material/snack-bar";

@Component({
  selector: 'app-order-list',
  templateUrl: './order-list.component.html',
  styleUrls: ['./order-list.component.css']
})
export class OrderListComponent implements OnInit{

  orders:any=[];
  searchOrderId: string = '';
  searchUserId: string = '';
  searchReservationId: string = '';
  selectedStatus: string = ''; // For selected status from dropdown
  fromDate: string = '';
  toDate: string = '';

  ordersService=inject(OrdersService);
  snackBar = inject(MatSnackBar);

  getOrders(): void {
    this.ordersService.getOrders().subscribe(
      orders => {
        this.orders = orders;
      },
      error => {
        this.showNotification('Failed to fetch orders');
      }
    );
  }

  applyOrderFilter(): void {
    if (this.searchOrderId.trim()) {
      this.ordersService.getOrderById(this.searchOrderId).subscribe(
        order => {
          this.orders = [order];
        },
        error => {
          this.showNotification(error.error.error); // 'Order not found'
        }
      );
    }
  }

  applyUserIdFilter(): void {
    if (this.searchUserId.trim()) {
      this.ordersService.getOrderByUserId(this.searchUserId).subscribe(
        orders => {
          this.orders = orders;
        },
        error => {
          this.showNotification(error.error.error);
        }
      );
    }
  }

  applyReservationIdFilter(): void {
    if (this.searchReservationId.trim()) {
      this.ordersService.getOrderByReservationId(this.searchReservationId).subscribe(
        orders => {
          this.orders = orders;
        },
        error => {
          this.showNotification(error.error.error);
        }
      );
    }
  }
  applyStatusFilter(): void {
    if (this.selectedStatus) {
      this.ordersService.getOrdersByStatus(this.selectedStatus).subscribe(
        orders => {
          this.orders = orders;
        },
        error => {
          this.showNotification(error.error.error);
        }
      );
    } else {
      this.getOrders(); // Fetch all orders if no status selected
    }
  }

  applyDateFilter(): void {
    if (this.fromDate && this.toDate) {
      const formattedFromDate = this.convertDate(this.fromDate);
      const formattedToDate = this.convertDate(this.toDate);

      this.ordersService.getOrdersByDateRange(formattedFromDate, formattedToDate).subscribe(
        orders => {
          this.orders = orders;
        },
        error => {
          this.showNotification(error.error.error);
        }
      );
    }
  }



  convertDate(date: string): string {
    const parsedDate = new Date(date);
    const year = parsedDate.getFullYear();
    const month = ('0' + (parsedDate.getMonth() + 1)).slice(-2); // Months are zero-indexed
    const day = ('0' + parsedDate.getDate()).slice(-2);
    return `${year}-${month}-${day}`;
  }


  resetFilters(): void {
    this.searchOrderId = '';
    this.searchUserId = '';
    this.searchReservationId = '';
    this.selectedStatus = ''; // Reset status to "All Status"
    this.fromDate = '';
    this.toDate = '';
    this.getOrders(); // Reset filters and fetch all orders
  }

  showNotification(message: string): void {
    this.snackBar.open(message, 'Close', {
      duration: 4000, // Duration in milliseconds
    });
  }
  ngOnInit(): void {
    this.getOrders();
  }

}
