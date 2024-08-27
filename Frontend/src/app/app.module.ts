import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LoginComponent } from './login/login.component';
import {FormsModule} from "@angular/forms";
import { SignupComponent } from './signup/signup.component';
import {HttpClientModule} from "@angular/common/http";
import { DashboardComponent } from './dashboard/dashboard.component';
import { UserReservationComponent } from './user-reservation/user-reservation.component';
import { MenuPageComponent } from './menu-page/menu-page.component';
import { ReservationTableComponent } from './reservation-table/reservation-table.component';
import { MonthlySalesComponent } from './monthly-sales/monthly-sales.component';
import { YearlySalesComponent } from './yearly-sales/yearly-sales.component';
import { MenuItemOrdersComponent } from './menu-item-orders/menu-item-orders.component';
import { FeedbackTrackingComponent } from './feedback-tracking/feedback-tracking.component';

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    SignupComponent,
    DashboardComponent,
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
    HttpClientModule,
    AppRoutingModule,
    FormsModule,
    AppRoutingModule,
    HttpClientModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
