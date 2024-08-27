import { Component, OnInit } from '@angular/core';
import { ReportingService } from '../reporting.service';

@Component({
  selector: 'app-yearly-sales',
  templateUrl: './yearly-sales.component.html'
})
export class YearlySalesComponent implements OnInit {

  yearlySales: any[] = [];

  constructor(private ReportingService: ReportingService) { }

  ngOnInit(): void {
    this.ReportingService.getYearlySales().subscribe(data => {
      this.yearlySales = data;
    });
  }
}
