import { Component } from '@angular/core';
import {LoginComponent } from './login/login.component';
import {Router} from "@angular/router";
@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'Frontend';
  constructor(private router: Router) {}

  isLoginOrSignupPage(): boolean {
    return this.router.url === '/login' || this.router.url === '/signup';
  }
}
