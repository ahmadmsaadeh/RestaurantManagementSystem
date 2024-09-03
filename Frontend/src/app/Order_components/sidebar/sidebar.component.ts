import {AfterViewInit, Component} from '@angular/core';
import {RouterLink} from "@angular/router";
import {AppModule} from "../../app.module";
import {UserService} from "../../dashboard/service/userservice";
import {UserlistService} from "../../userlist/service/userlist.service";
import {NgIf} from "@angular/common";


@Component({
  selector: 'app-sidebar',
  templateUrl: './sidebar.component.html',
  standalone: true,

  imports: [
    RouterLink,
    NgIf
  ],
  styleUrls: ['./sidebar.component.css'],

})
export class SidebarComponent implements AfterViewInit {
 
  ngAfterViewInit(): void {
    const hamBurger = document.querySelector(".toggle-btn");
    const sidebar = document.querySelector("#sidebar");

    hamBurger?.addEventListener("click", function () {
      sidebar?.classList.toggle("expand");


    });


  }

  userType: string = '';
  Useeremail: string = ' ';

  constructor(public userService: UserService) {}

  ngOnInit(): void {
    this.userType = this.userService.getUserType();
    this.Useeremail = this.userService.getUseremail();
    console.log('User Type:', this.userType);
    console.log('User email:', this.Useeremail);

  }
}
