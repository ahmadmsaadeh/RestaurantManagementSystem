import {Component, inject, OnInit} from '@angular/core';
import {OrdersService} from "../../services/orders.service";
import {ActivatedRoute, RouterLink} from "@angular/router";
import {CurrencyPipe, NgForOf} from "@angular/common";
import jsPDF from 'jspdf';
import 'jspdf-autotable';
import autoTable from "jspdf-autotable";

@Component({
  selector: 'app-order-details',
  templateUrl: './order-details.component.html',
  standalone: true,
  imports: [
    CurrencyPipe,
    NgForOf,
    RouterLink
  ],
  styleUrls: ['./order-details.component.css']
})
export class OrderDetailsComponent implements OnInit{
  order: any;
  orderItems: any[] = [];
  total: number = 0;

  ordersService=inject(OrdersService);

  constructor( private route: ActivatedRoute,) {
  }
  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    if (id) {
      this.fetchOrderDetails(id);
      this.fetchOrderItems(id);
    }
  }

  fetchOrderDetails(orderId: string): void {
    this.ordersService.getOrderById(orderId).subscribe(data => {
      this.order = data;
    });
  }

  fetchOrderItems(orderId: string): void {
    this.ordersService.getOrderItems(orderId).subscribe(response => {
      this.orderItems = response.Items;
      this.total = response.total;
    });
  }


  generatePDF(): jsPDF {
    const doc = new jsPDF();

    // Add Restaurant Logo
    var img = new Image();
    img.src = 'assets/newlogo.png';
    doc.addImage(img, 'PNG', 10, 10, 60, 40); // Adjust the position and size as needed

    // Add Restaurant Name
    doc.setFontSize(26);
    doc.setFont('Helvetica', 'bold');
    doc.text(`INVOICE`, 105, 60, { align: 'center' });

    // Add Order Details Title
    doc.setFontSize(24);
    doc.setFont('Helvetica', 'normal');
    doc.text('Order Details', 105, 90, { align: 'center' });

    // Add Order Details
    doc.setFontSize(18);
    doc.text(`Order ID: ${this.order.order_id}`, 20, 100);
    doc.text(`Reservation ID: ${this.order.reservation_no}`, 20, 110);
    doc.text(`Order Date: ${this.order.order_date}`, 20, 120);
    doc.text(`Order Time: ${this.order.order_time}`, 20, 130);

    // Add Order Items Table
    const headers = [['Item ID', 'Item Name', 'Quantity', 'Price', 'Subtotal']];
    const data = this.orderItems.map(item => [
      item.menu_item_id,
      item.item_name,
      item.quantity,
      item.price,
      `$${item.subtotal}`
    ]);

    autoTable(doc, {
      head: headers,
      body: data,
      startY: 140, // Start the table below the order details
      theme: 'striped',
      styles: {
        fillColor: [255, 255, 255], // Background color for cells
        textColor: [0, 0, 0], // Text color
        fontSize: 15, // Font size
      },
      headStyles: {
        fillColor: [227, 98, 98], // Header background color (blue example)
        textColor: [255, 255, 255], // Header text color
      },
      alternateRowStyles: {
        fillColor: [240, 240, 240], // Alternate row background color (light gray example)
      },
    });

    doc.text(`Total Amount: $${this.total}`,17,200 );
    // doc.text('Order Details', 105, 90, { align: 'center' });
    return doc;
  }



  savePDF(): void {
    const doc = this.generatePDF();
    doc.save('order-details.pdf');
  }

  printPDF(): void {
    const doc = this.generatePDF();
    // Use `doc.output('blob')` to create a Blob from the PDF and open it in a new tab for printing
    const pdfBlob = doc.output('blob');
    const pdfUrl = URL.createObjectURL(pdfBlob);
    const printWindow = window.open(pdfUrl, '_blank');
    printWindow?.addEventListener('load', () => {
      printWindow.print();
    });
  }

}




