import { Component, OnInit } from '@angular/core';
import { forkJoin } from 'rxjs';
import { ReservationService } from './reservation-table-service/reservation.service';

@Component({
  selector: 'app-reservation-table',
  templateUrl: './reservation-table.component.html',
  styleUrls: ['./reservation-table.component.css']
})
export class ReservationTableComponent implements OnInit {
  reservations: any[] = [];

  constructor(private reservationService: ReservationService) {}

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

  refreshTable(): void {
    this.loadReservations();
  }

}
