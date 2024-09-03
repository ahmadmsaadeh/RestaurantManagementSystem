import { Component, OnInit } from '@angular/core';
import { ReportingService } from '../../../services/reporting.service';
@Component({
  selector: 'app-monthly-sales',
  templateUrl: './monthly-sales.component.html',
  styleUrls: ['./monthly-sales.component.css']
})

export class MonthlySalesComponent implements OnInit {

  monthlySales: any[] = [];

  constructor(private ReportingService: ReportingService) { }

  ngOnInit(): void {
    this.ReportingService.getMonthlySales().subscribe(data => {
      this.monthlySales = data;
    });
  }
}
