import { Component, OnInit } from '@angular/core';
import { ReportingService } from '../../../services/reporting.service';

@Component({
  selector: 'app-menu-item-orders',
  templateUrl: './menu-item-orders.component.html'
})
export class MenuItemOrdersComponent implements OnInit {

  menuItems: any[] = [];

  constructor(private ReportingService: ReportingService) { }

  ngOnInit(): void {
    this.ReportingService.getMenuItemOrders().subscribe(data => {
      this.menuItems = data;
    });
  }
}
