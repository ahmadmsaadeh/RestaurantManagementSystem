import {Component, inject, Input, OnInit} from '@angular/core';
import {OrdersService} from "./services/orders.service";
import {MatSnackBar} from "@angular/material/snack-bar";

import {LoginComponent } from './login/login.component';
import {Router} from "@angular/router";
@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent{
  title = 'Frontend';
  constructor(private router: Router) {}

  isLoginOrSignupPage(): boolean {
    return this.router.url === '/login' || this.router.url === '/signup';
  }
}
