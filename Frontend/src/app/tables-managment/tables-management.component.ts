import {Component, ElementRef, ViewChild} from '@angular/core';
import {TableServicesService} from "./table-service/table-services.service";

@Component({
  selector: 'app-tables-managment',
  templateUrl: './tables-management.component.html',
  styleUrls: ['./tables-management.component.css']
})
export class TablesManagementComponent {
  @ViewChild('numOfChairs') numOfChairs!: ElementRef;
  tables: any[] = [];

  constructor(private tableService: TableServicesService) {
  }

  ngOnInit(): void {
    this.loadContents();
  }

  loadContents(): void {
    this.tableService.getAllTables().subscribe((tables: any[]) => {
        this.tables = tables;
      },
      error => {
        console.error('Error fetching tables', error);
      });
  }

  deleteTable(id: number): void {
    this.tableService.deleteTable(id).subscribe(()=> {
      this.loadContents();
      window.alert("Table deleted successfully.");
    },error => {
      let errorMessage = '';
      if (error.status === 400) {
        errorMessage = 'Table cannot be deleted because it has active reservations';
      } else if (error.status === 404) {
        errorMessage = 'Table not found';
      } else {
        errorMessage = 'Error deleting table';
      }
      window.alert(errorMessage); // Show error alert
      console.error('Error deleting table', error);
    });
  }

  onsubmit(): void{
    const numberOfChairs = Math.floor(this.numOfChairs.nativeElement.value);
    this.tableService.addTable(numberOfChairs).subscribe(()=> {
      this.loadContents();
    },error => {
      console.error('Error Adding table', error);
      if (error.status === 400) {
        window.alert("Invalid Number Of Chairs.");
      }
      else window.alert("Table Can't be added, please try again later.");
    })
  }
}
