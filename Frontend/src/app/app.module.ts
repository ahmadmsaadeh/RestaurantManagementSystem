import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { UserReservationComponent } from './user-reservation/user-reservation.component';
import {FormsModule} from "@angular/forms";
import { MenuPageComponent } from './menu-page/menu-page.component';
import { HttpClientModule } from '@angular/common/http';
import { ReservationTableComponent } from './reservation-table/reservation-table.component';
import { MonthlySalesComponent } from './monthly-sales/monthly-sales.component';
import { YearlySalesComponent } from './yearly-sales/yearly-sales.component';
import { MenuItemOrdersComponent } from './menu-item-orders/menu-item-orders.component';
import { FeedbackTrackingComponent } from './feedback-tracking/feedback-tracking.component';

@NgModule({
  declarations: [
    AppComponent,
    UserReservationComponent,
    AppComponent,
    MenuPageComponent,
    ReservationTableComponent,
    MonthlySalesComponent,
    YearlySalesComponent,
    MenuItemOrdersComponent,
    FeedbackTrackingComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule,
    AppRoutingModule,
    HttpClientModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
