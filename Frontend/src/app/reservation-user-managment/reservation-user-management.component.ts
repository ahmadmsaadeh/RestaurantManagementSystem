import { Component, OnInit } from '@angular/core';
import { ReservationService } from '../reservation-table/reservation-table-service/reservation.service';
import {LoginService} from "../login/service/LoginService";
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';

@Component({
  selector: 'app-reservation-user-management',
  templateUrl: './reservation-user-management.component.html',
  styleUrls: ['./reservation-user-management.component.css']
})
export class ReservationUserManagementComponent implements OnInit {
  reservations: any[] = [];
  selectedReservation: any = null;
  userId:number | null = 1;

  constructor(
    private reservationService: ReservationService,
    private modalService: NgbModal,
    private loginService: LoginService,
  ) {
    this.userId=loginService.getUserId();
    console.log(this.userId);
  }

  ngOnInit(): void {
    this.loadUserReservations();
  }

  loadUserReservations(): void {
    this.reservationService.getUserReservations(this.userId!).subscribe(
      (reservations: any[]) => {
        this.reservations = reservations;
      },
      error => {
        console.error('Error fetching reservations', error);
      }
    );
  }

  openReservationDetails(reservation: any, content: any): void {
    this.selectedReservation = reservation;
    this.modalService.open(content, { ariaLabelledBy: 'modal-basic-title' }).result.then(
      () => {}, // Handle modal close
      () => {}  // Handle modal dismiss
    );
  }

  deleteReservation(ResID: any, modal: any): void {
    this.reservationService.deleteReservation(ResID).subscribe(() => {
      this.loadUserReservations();
      modal.close();
    }, error => {
      console.error('Error deleting reservation', error);
    });
  }
}
