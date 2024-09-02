import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import {UserService} from "../userservice";

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css']
})


export class DashboardComponent implements OnInit {
  userType: string = '';

  constructor(private userService: UserService) {}

  ngOnInit(): void {
    this.userType = this.userService.getUserType();
    console.log('User Type:', this.userType);
  }
}
