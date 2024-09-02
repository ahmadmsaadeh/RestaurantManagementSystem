// app.component.ts
import { Component, OnInit } from '@angular/core';
import {LoginService} from "./LoginService";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit {
  showNavbar: boolean = true;

  constructor(private loginService: LoginService) {}

  ngOnInit() {
    // Subscribe to showNavbar$ to reflect login state
    this.loginService.showNavbar$.subscribe((show: boolean) => {
      console.log('Navbar visibility changed:', show); // Debug log
      this.showNavbar = show;
    });
  }
}
