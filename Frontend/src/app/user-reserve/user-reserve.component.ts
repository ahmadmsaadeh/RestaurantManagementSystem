import {AfterViewInit, Component, ElementRef, ViewChild} from '@angular/core';
import {GetUserReservationService} from "../user-reservation/get-user-reservation/get-user-reservation.service";
import {LoginService} from "../login/service/LoginService";
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
  userId:number | null = 1;

  constructor(
    private reservationService: GetUserReservationService,
    private loginService: LoginService,
  ) {
    this.userId=loginService.getUserId();
    console.log(this.userId);
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
    this.reservationService.createReservation(this.userId!, date, time, numOfCustomers, reservationType)
      .subscribe(response => {
        window.alert("Reservation created successfully");
      }, error => {
        window.alert("Error creating reservation");
      });
  }
}
