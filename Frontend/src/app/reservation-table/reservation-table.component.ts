import { Component, OnInit } from '@angular/core';
import { ReservationService } from './reservation-table-service/reservation.service';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import {Observable} from "rxjs";

@Component({
  selector: 'app-reservation-table',
  templateUrl: './reservation-table.component.html',
  styleUrls: ['./reservation-table.component.css']
})
export class ReservationTableComponent implements OnInit {
  reservations: any[] = [];
  user: any[] =[];
  selectedReservation: any = null;
  username: any = null;

  constructor(
    private reservationService: ReservationService,
    private modalService: NgbModal
  ) {}

  ngOnInit(): void {
    this.loadReservations();
  }

  loadReservations(): void {
    this.reservationService.getReservations().subscribe((reservations: any[]) => {
      this.reservations = reservations;

      // For each reservation, fetch the username
      this.reservations.forEach(reservation => {
        this.reservationService.getUsername(reservation.UserID).subscribe(username => {
          reservation.username = username;  // Store the username in the reservation object
        });
      });
    }, error => {
      console.error('Error fetching reservations', error);
    });
  }

  openReservationDetails(reservation: any, content: any) {
    this.selectedReservation = reservation;
    this.modalService.open(content, { ariaLabelledBy: 'modal-basic-title' }).result.then(
      (result) => {
        // Handle result if needed
      },
      (reason) => {
        // Handle dismiss if needed
      }
    );
  }

  deleteReservation(ResID: any, modal: any): void {
    this.reservationService.deleteReservation(ResID).subscribe(() => {
      this.loadReservations(); // Refresh the reservations after deletion
      modal.close(); // Close the modal after deletion
    }, error => {
      console.error('Error deleting reservation', error);
    });
  }

  getUsername(UserID: any): Observable<any> {
   this.reservationService.getUser(UserID).subscribe((user: any[])=>{
     this.username = user.map(user => user.username )});
   return this.username;
  }

}
