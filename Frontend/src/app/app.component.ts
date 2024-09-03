// app.component.ts
import { Component, OnInit } from '@angular/core';
import {LoginService} from "./login/service/LoginService";
import {Router} from "@angular/router";
@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit {
  showNavbar: boolean = true;
  showLogin: boolean = true; // Initially show login section

  constructor(private loginService: LoginService,
              private router: Router) {}

  ngOnInit() {
    // Subscribe to showNavbar$ to reflect login state
    this.loginService.showNavbar$.subscribe((show: boolean) => {
      console.log('Navbar visibility changed:', show); // Debug log
      this.showNavbar = show;
    });
  }

  toggleSection(section: string) {
    if (section === 'login') {
      this.showLogin = true;
    } else {
      this.showLogin = false;
    }
  }
}
