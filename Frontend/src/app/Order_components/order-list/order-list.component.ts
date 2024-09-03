import {Component, inject, Input, OnInit} from '@angular/core';
import {OrdersService} from "../../services/orders.service";
import {MatSnackBar} from "@angular/material/snack-bar";
import {FormsModule} from "@angular/forms";
import {CurrencyPipe, NgForOf} from "@angular/common";
import {RouterLink} from "@angular/router";
import jsPDF from 'jspdf';
import 'jspdf-autotable';
import autoTable from "jspdf-autotable";

@Component({
  selector: 'app-order-list',
  templateUrl: './order-list.component.html',
  standalone: true,
  imports: [
    FormsModule,
    CurrencyPipe,
    RouterLink,
    NgForOf
  ],
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

  deleteOrder(orderId: string): void {
    this.ordersService.deleteOrder(orderId).subscribe(
      () => {
        // Remove the deleted order from the local list
        this.orders = this.orders.filter((order: any) => order.order_id !== orderId);
        this.showNotification('Order deleted successfully');
      },
      error => {
        this.showNotification('Failed to delete order');
      }
    );
  }

  generatePDF() {
    // Create a new PDF document.
    const doc = new jsPDF();

    // Add content to the PDF.
    doc.setFontSize(16);
    doc.text('My Angular PDF Generator', 20, 10);
    doc.setFontSize(12);
    doc.text(
      'This is a comprehensive guide on generating PDFs with Angular.',
      10,
      20,
    );

    // Create a table using `jspdf-autotable`.
    const headers = [['Name', 'Email', 'Country']];
    const data = [
      ['David', 'david@example.com', 'Sweden'],
      ['Castille', 'castille@example.com', 'Spain'],
      // ...
    ];

    autoTable(doc, {
      head: headers,
      body: data,
      startY: 30, // Adjust the `startY` position as needed.
    });

    // Save the PDF.
    doc.save('table.pdf');
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
