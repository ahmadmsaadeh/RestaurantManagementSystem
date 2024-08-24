import { Component, AfterViewInit, ElementRef, ViewChild } from '@angular/core';
import flatpickr from 'flatpickr';
import {english } from 'flatpickr/dist/l10n/default';
@Component({
  selector: 'app-date-time-pickr',
  templateUrl: './date-time-pickr.component.html',
  styleUrls: ['./date-time-pickr.component.css']
})
export class DateTimePickrComponent implements AfterViewInit {
  @ViewChild('dateTimePicker') dateTimePicker!: ElementRef;

  constructor() { }

  ngAfterViewInit(): void {
    flatpickr(this.dateTimePicker.nativeElement, {
      enableTime: true,
      dateFormat: 'Y-m-d H:i',
      locale: english, // Ensure correct locale
      time_24hr: true, // Enable 24-hour time format
      minuteIncrement: 10
    });
  }

  onSubmit(): void {
    console.log('Form submitted!');
  }
}
