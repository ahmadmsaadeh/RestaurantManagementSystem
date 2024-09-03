import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LoginComponent } from './login/login.component';
import { SignupComponent } from './signup/signup.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { UserReservationComponent } from './user-reservation/user-reservation.component';
import { MenuPageComponent } from './menu-page/menu-page.component';
import { ReservationTableComponent } from './reservation-table/reservation-table.component';
import { MonthlySalesComponent } from './ReportsComponents/monthly-sales/monthly-sales.component';
import { YearlySalesComponent } from './ReportsComponents/yearly-sales/yearly-sales.component';
import { MenuItemOrdersComponent } from './ReportsComponents/menu-item-orders/menu-item-orders.component';
import { FeedbackTrackingComponent } from './ReportsComponents/feedback-tracking/feedback-tracking.component';
import { RoleslistComponent } from './roleslist/roleslist.component';
import {SidebarComponent} from "./Order_components/sidebar/sidebar.component";
import {CommonModule, NgOptimizedImage} from "@angular/common";
import { HeaderComponent } from './Order_components/header/header.component';
import { OrderListComponent } from './Order_components/order-list/order-list.component';
import {HttpClient, HttpClientModule} from "@angular/common/http";
import {OrdersService} from "./services/orders.service";
import {FormsModule} from "@angular/forms";
import {MatSnackBarModule} from "@angular/material/snack-bar";
import {BrowserAnimationsModule} from "@angular/platform-browser/animations";

import { MatToolbarModule } from '@angular/material/toolbar';
import { MatSidenavModule } from '@angular/material/sidenav';
import { MatTableModule } from '@angular/material/table';
import { MatInputModule } from '@angular/material/input';
import { MatSelectModule } from '@angular/material/select';
import {MatButtonModule} from "@angular/material/button";
import {MatIconModule} from "@angular/material/icon";
import {MatMenuModule} from "@angular/material/menu";
import {MatTooltipModule} from "@angular/material/tooltip";
import {MatNativeDateModule} from "@angular/material/core";
import {MatDatepickerModule} from "@angular/material/datepicker";
import { OrderDetailsComponent } from './Order_components/order-details/order-details.component';
import { SideWithContentComponent } from './Order_components/side-with-content/side-with-content.component';
import { ReservationUserManagementComponent } from './reservation-user-managment/reservation-user-management.component';
import { MenuEditComponent } from './menu-edit/menu-edit.component';
import { MatCardModule } from '@angular/material/card';
import { AddOrderComponent } from './Order_components/add-order/add-order.component';

import { ReactiveFormsModule } from '@angular/forms';
import { TablesManagementComponent } from './tables-managment/tables-management.component';
import { FullscreenBackgroundComponent } from './fullscreen-background/fullscreen-background.component';
import { FeedbackComponent } from './FeedbackComponents/feedback/feedback.component';

import { ReportsComponent } from './ReportsComponents/reports/reports.component';

import { UserReserveComponent } from './user-reserve/user-reserve.component';

import { EditlistComponent } from './editlist/editlist.component';

import { ShowFeedbackComponent } from './FeedbackComponents/show-feedback/show-feedback.component';
import { SliderHomeComponent } from './slider-home/slider-home.component';
import {ChefsComponent} from "./chefs/chefs.component";
import { FooterComponent } from './footer/footer.component';

import { UpdateDeleteFeedbackComponent } from './FeedbackComponents/update-delete-feedback/update-delete-feedback.component';




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
    FeedbackTrackingComponent,
    RoleslistComponent,
    SideWithContentComponent,
    ReservationUserManagementComponent,
    MenuEditComponent,

    TablesManagementComponent,
    FeedbackComponent,


    AddOrderComponent,

    AddOrderComponent,
   TablesManagementComponent,
   FullscreenBackgroundComponent,

   ReportsComponent,
   UserReserveComponent,
     EditlistComponent,
     ShowFeedbackComponent,

     UpdateDeleteFeedbackComponent,

     SliderHomeComponent,
    ChefsComponent,
    FooterComponent,



  ],
    imports: [
        BrowserModule,
        AppRoutingModule,
        HttpClientModule,
        CommonModule,
        FormsModule,
        AppRoutingModule,
        HttpClientModule,
        AppRoutingModule,
        HttpClientModule,
        FormsModule,
        MatSnackBarModule,
        BrowserAnimationsModule,
        MatDatepickerModule,
        MatInputModule,
        MatNativeDateModule,
        MatButtonModule,
        MatIconModule,
        SidebarComponent,
        MatSelectModule,
        MatTableModule,
        ReactiveFormsModule,
        NgOptimizedImage

    ],
  providers: [OrdersService],
  bootstrap: [AppComponent]
})
export class AppModule { }
