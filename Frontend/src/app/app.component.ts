import { Component, OnInit } from '@angular/core';
import { LoginService } from './login/service/LoginService';
import { Router } from '@angular/router';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit {
  showNavbar: boolean = true;

  constructor(private loginService: LoginService, private router: Router) {}

  ngOnInit() {
    this.loginService.showNavbar$.subscribe((show: boolean) => {
      console.log('Navbar visibility changed:', show);
      this.showNavbar = show;
    });
  }

  navigateTo(route: string) {
    this.router.navigate([route]);
  }
}
