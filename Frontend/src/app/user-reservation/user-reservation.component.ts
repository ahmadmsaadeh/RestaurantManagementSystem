import { Component, ElementRef, ViewChild, AfterViewInit } from '@angular/core';
import flatpickr from "flatpickr";
import { english } from "flatpickr/dist/l10n/default";
import { GetUserReservationService } from './get-user-reservation/get-user-reservation.service';

@Component({
  selector: 'app-user-reservation',
  templateUrl: './user-reservation.component.html',
  styleUrls: ['./user-reservation.component.css']
})
export class UserReservationComponent implements AfterViewInit {
  @ViewChild('dateTimePicker') dateTimePicker!: ElementRef;
  @ViewChild('numberOfCustomers') numberOfCustomers!: ElementRef;
  @ViewChild('reservationType') reservationType!: ElementRef;

  userId: number = 1;  // Suppose the user ID is set to 1

  constructor(private reservationService: GetUserReservationService) {}

  ngAfterViewInit(): void {
    flatpickr(this.dateTimePicker.nativeElement, {
      enableTime: true,
      dateFormat: 'Y-m-d H:i',
      locale: english,
      time_24hr: true,
      minuteIncrement: 10
    });
  }

  openDateTimePicker(): void {
    const flatpickrInstance = (this.dateTimePicker.nativeElement as any)._flatpickr;
    if (flatpickrInstance) {
      flatpickrInstance.open();
    }
  }

  onSubmit(): void {
    const dateTime = this.dateTimePicker.nativeElement.value;
    const numOfCustomers = this.numberOfCustomers.nativeElement.value;
    const reservationType = this.reservationType.nativeElement.value;
    const [date, time] = dateTime.split(' ');

    this.reservationService.createReservation(this.userId, date, time, numOfCustomers, reservationType)
      .subscribe(response => {
        console.log('Reservation created successfully', response);
      }, error => {
        console.error('Error creating reservation', error);
      });
  }

}
