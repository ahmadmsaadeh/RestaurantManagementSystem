import {AfterViewInit, Component, ElementRef, ViewChild} from '@angular/core';
import flatpickr from "flatpickr";
import {english} from "flatpickr/dist/l10n/default";

@Component({
  selector: 'app-user-reservation',
  templateUrl: './user-reservation.component.html',
  styleUrls: ['./user-reservation.component.css']
})
export class UserReservationComponent implements AfterViewInit {
@ViewChild('dateTimePicker') dateTimePicker!: ElementRef;

  constructor() { }

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
    console.log('Form submitted!');
  }
}
