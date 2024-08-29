import { Component, ElementRef, ViewChild, AfterViewInit, OnInit } from '@angular/core';
import flatpickr from "flatpickr";
import { english } from "flatpickr/dist/l10n/default";
import { GetUserReservationService } from './get-user-reservation/get-user-reservation.service';

@Component({
  selector: 'app-user-reservation',
  templateUrl: './user-reservation.component.html',
  styleUrls: ['./user-reservation.component.css']
})
export class UserReservationComponent implements AfterViewInit, OnInit {
  @ViewChild('dateTimePicker') dateTimePicker!: ElementRef;
  @ViewChild('numberOfCustomers') numberOfCustomers!: ElementRef;
  @ViewChild('reservationType') reservationType!: ElementRef;
  @ViewChild('userSelect') userSelect!: ElementRef; // Reference to the user select element

  users: any[] = [];
  selectedUserId: number = 1;  // Default selected user ID

  constructor(
    private reservationService: GetUserReservationService,
    private userService: GetUserReservationService  // Inject the user service
  ) {}

  ngOnInit(): void {
    this.fetchUsers();
  }

  fetchUsers(): void {
    this.userService.getUsers().subscribe(users => {
      this.users = users;
    }, error => {
      console.error('Error fetching users', error);
    });
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
    const userId = this.userSelect.nativeElement.value;
    const [date, time] = dateTime.split(' ');

    this.reservationService.createReservation(userId, date, time, numOfCustomers, reservationType)
      .subscribe(response => {
        console.log('Reservation created successfully', response);
      }, error => {
        console.error('Error creating reservation', error);
      });
  }
}
