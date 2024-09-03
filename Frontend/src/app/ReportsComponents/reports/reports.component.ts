import { Component, OnInit } from '@angular/core';
import * as echarts from 'echarts';
import { ReportingService } from '../../services/reporting.service';

@Component({
  selector: 'app-reports',
  templateUrl: './reports.component.html',
  styleUrls: ['./reports.component.css']
})
export class ReportsComponent implements OnInit {

  constructor(private reportingService: ReportingService) { }

  ngOnInit(): void {
    this.renderLineChartMonthlySales();
    this.renderLineChartYearlySales();
    this.renderPieChart();
    this.renderBarChart();
    this.renderMonthlyFeedbackChart();
  }

  renderLineChartMonthlySales() {
    this.reportingService.getMonthlySales().subscribe(data => {
      const chartDom = document.getElementById('monthlySalesChart')!;
      const myChart = echarts.init(chartDom);
      const option = {
        tooltip: {
          trigger: 'axis'
        },
        xAxis: {
          type: 'category',
          data: data.map(d => d.month)
        },
        yAxis: {
          type: 'value'
        },
        series: [{
          data: data.map(d => d.total),
          type: 'line',
          smooth: true
        }]
      };
      myChart.setOption(option);
    });
  }

  renderLineChartYearlySales() {
    this.reportingService.getYearlySales().subscribe(data => {
      const chartDom = document.getElementById('yearlySalesChart')!;
      const myChart = echarts.init(chartDom);
      const option = {
        tooltip: {
          trigger: 'axis'
        },
        xAxis: {
          type: 'category',
          data: data.map(d => d.year.toString())
        },
        yAxis: {
          type: 'value'
        },
        series: [{
          data: data.map(d => d.total),
          type: 'line',
          smooth: true
        }]
      };
      myChart.setOption(option);
    });
  }

  renderPieChart() {
    this.reportingService.getFeedbackAverage().subscribe(data => {
      const chartDom = document.getElementById('pieChartE')!;
      const myChart = echarts.init(chartDom);
      const option = {
        tooltip: {
          trigger: 'item'
        },
        series: [{
          name: 'Feedback',
          type: 'pie',
          radius: '50%',
          data: data.map(d => ({ value: d.count, name: d.category }))
        }]
      };
      myChart.setOption(option);
    });
  }

  renderBarChart() {
    this.reportingService.getMenuItemOrders().subscribe(data => {
      const chartDom = document.getElementById('barChartE')!;
      const myChart = echarts.init(chartDom);
      const option = {
        tooltip: {
          trigger: 'axis'
        },
        xAxis: {
          type: 'category',
          data: data.map(d => d.name),
          axisLabel: {
            color: '#333',              // Text color
            fontSize: 12,               // Font size
            fontFamily: 'Arial',        // Font family
            rotate: 45,                 // Rotate labels to avoid overlap
            margin: 15,                 // Space between labels and axis
            formatter: (value: string) => value.length > 10 ? value.substring(0, 10) + '...' : value // Truncate long labels
          },
          axisLine: {
            lineStyle: {
              color: '#000',            // Axis line color
              width: 2                  // Axis line width
            }
          },
          axisTick: {
            lineStyle: {
              color: '#000',            // Tick line color
              width: 2                  // Tick line width
            }
          }
        },
        yAxis: {
          type: 'value'
        },
        series: [{
          data: data.map(d => d.ordersCount),
          type: 'bar'
        }]
      };
      myChart.setOption(option);
    });
  }

  renderMonthlyFeedbackChart() {
    this.reportingService.getMonthlyFeedback().subscribe(data => {
      const chartDom = document.getElementById('monthlyFeedbackChart')!;
      const myChart = echarts.init(chartDom);
      const option = {
        tooltip: {
          trigger: 'axis'
        },
        xAxis: {
          type: 'category',
          data: data.map((d: { month: any; }) => d.month),
          axisLabel: {
            color: '#333',
            fontSize: 12,
            fontFamily: 'Arial',
            rotate: 45,
            margin: 15,
            formatter: (value: string) => value.length > 10 ? value.substring(0, 10) + '...' : value
          },
          axisLine: {
            lineStyle: {
              color: '#000',
              width: 2
            }
          },
          axisTick: {
            lineStyle: {
              color: '#000',
              width: 2
            }
          }
        },
        yAxis: {
          type: 'value'
        },
        series: [{
          data: data.map((d: { averageScore: any; }) => d.averageScore),
          type: 'line',
          smooth: true
        }]
      };
      myChart.setOption(option);
    });
  }
}
