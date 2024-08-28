import { Component, OnInit } from '@angular/core';
import { ReservationService } from './reservation-table-service/reservation.service';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { forkJoin } from 'rxjs';


@Component({
  selector: 'app-reservation-table',
  templateUrl: './reservation-table.component.html',
  styleUrls: ['./reservation-table.component.css']
})
export class ReservationTableComponent implements OnInit {
  reservations: any[] = [];
  selectedReservation: any = null;

  constructor(private reservationService: ReservationService, private modalService: NgbModal) {}

  ngOnInit(): void {
    this.loadReservations();
  }

  loadReservations(): void {
    this.reservationService.getReservations().subscribe((reservations: any[]) => {
      const userRequests = reservations.map(reservation =>
        this.reservationService.getUser(reservation.UserID)
      );

      forkJoin(userRequests).subscribe(userResponses => {
        reservations.forEach((reservation, index) => {
          reservation.username = userResponses[index].username;
        });
        this.reservations = reservations;
      });
    }, error => {
      console.error('Error fetching reservations or user data', error);
    });
  }

  openReservationDetails(reservation: any, content: any) {
    this.selectedReservation = reservation;
    this.modalService.open(content, { ariaLabelledBy: 'modal-basic-title' }).result.then((result) => {
    }, (reason) => {
    });
  }

  openModal(reservation: any): void {
    this.selectedReservation = reservation;
    this.modalService.open('#reservationModal', { backdrop: 'static', keyboard: false });
  }

  closeModal(modal: any): void {
    modal.close();
  }

  deleteReservation(ResID: any, modal: any) {
    this.reservationService.deleteReservation(ResID).subscribe(() => {
      this.loadReservations();
      modal.close();
    }, error => {
      console.error('Error deleting reservation', error);
    });
  }
}
