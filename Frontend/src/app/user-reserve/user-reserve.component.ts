import {AfterViewInit, Component, ElementRef, ViewChild} from '@angular/core';
import {GetUserReservationService} from "../user-reservation/get-user-reservation/get-user-reservation.service";
import flatpickr from "flatpickr";
import {english} from "flatpickr/dist/l10n/default";

@Component({
  selector: 'app-user-reserve',
  templateUrl: './user-reserve.component.html',
  styleUrls: ['./user-reserve.component.css']
})
export class UserReserveComponent implements AfterViewInit {
  @ViewChild('dateTimePicker') dateTimePicker!: ElementRef;
  @ViewChild('numberOfCustomers') numberOfCustomers!: ElementRef;
  @ViewChild('reservationType') reservationType!: ElementRef;

  users: any[] = [];
  selectedUserId: number = 1;  // Default selected user ID

  constructor(
    private reservationService: GetUserReservationService,
  ) {
  }
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

    this.reservationService.createReservation(this.selectedUserId, date, time, numOfCustomers, reservationType)
      .subscribe(response => {
        console.log('Reservation created successfully', response);
      }, error => {
        console.error('Error creating reservation', error);
      });
  }
}
