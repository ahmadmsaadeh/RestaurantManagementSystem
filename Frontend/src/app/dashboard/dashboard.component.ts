import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import {UserService} from "./service/userservice";

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css']
})


export class DashboardComponent implements OnInit {
  userType: string = '';
  Useeremail: string = ' ';

  constructor(private userService: UserService) {}

  ngOnInit(): void {
    this.userType = this.userService.getUserType();
    this.Useeremail = this.userService.getUseremail();
    console.log('User Type:', this.userType);
    console.log('User email:', this.Useeremail);

  }
}
