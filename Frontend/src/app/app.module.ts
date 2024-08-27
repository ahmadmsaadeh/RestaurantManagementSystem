import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { HeaderComponent } from './Order_components/header/header.component';
import { SidebarComponent } from './Order_components/sidebar/sidebar.component';
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

@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    SidebarComponent,
    OrderListComponent,
    OrderDetailsComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    FormsModule,
    MatSnackBarModule,
    BrowserAnimationsModule, // Add BrowserAnimationsModule here

    MatDatepickerModule,
    MatInputModule,
    MatNativeDateModule,
    MatButtonModule,
    MatIconModule,

    /*
    MatToolbarModule,
    MatSidenavModule,
    MatButtonModule,
    MatIconModule,
    MatTableModule,
    MatInputModule,
    MatSelectModule,
    MatMenuModule   */
  ],
  providers: [OrdersService],
  bootstrap: [AppComponent]
})
export class AppModule { }
