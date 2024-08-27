import {Component, inject, OnInit} from '@angular/core';
import {OrdersService} from "../../services/orders.service";
import {ActivatedRoute} from "@angular/router";

@Component({
  selector: 'app-order-details',
  templateUrl: './order-details.component.html',
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
}




