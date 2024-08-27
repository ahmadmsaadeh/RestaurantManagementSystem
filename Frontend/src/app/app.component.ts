import {Component, inject, Input, OnInit} from '@angular/core';
import {OrdersService} from "./services/orders.service";
import {MatSnackBar} from "@angular/material/snack-bar";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent{
  title = 'Frontend';
}
