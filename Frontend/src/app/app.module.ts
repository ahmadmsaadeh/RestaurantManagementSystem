import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { UserReservationComponent } from './user-reservation/user-reservation.component';
import {FormsModule} from "@angular/forms";
import { DateTimePickrComponent } from './date-time-pickr/date-time-pickr.component';
@NgModule({
  declarations: [
    AppComponent,
    UserReservationComponent,
    DateTimePickrComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
