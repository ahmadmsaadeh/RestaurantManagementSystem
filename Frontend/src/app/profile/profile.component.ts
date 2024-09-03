import { Component, OnInit } from '@angular/core';
import {UserlistService} from "../userlist/service/userlist.service";
import {LoginService} from "../login/service/LoginService";
import {FormsModule} from "@angular/forms";
import {NgIf} from "@angular/common";


@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  standalone: true,
  imports: [
    FormsModule,
    NgIf
  ],
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent implements OnInit {
  user: any = {
    username: '',
    email: '',
    firstname: '',
    lastname: '',
    phonenumber: ''
  };
  updateSuccess = false;
  updateError = false;
  userId: number | null = null;

  constructor(private userListService: UserlistService , private loginservice : LoginService) {}

  ngOnInit(): void {
    this.userId = this.loginservice.getUserId();
    if (this.userId) {
      this.loadUserProfile(this.userId);
    } else {
      alert('User ID not found. Please log in again.');
    }
  }

  loadUserProfile(userId: number) {
    this.userListService.getUserById(userId).subscribe(
      (response: any) => {
        if (response.success) {
          this.user = response.user;
        } else {
          alert('User not found');
        }
      },
      error => {
        console.error('Error fetching user profile', error);
        alert('Error fetching user profile. Please try again later.');
      }
    );
  }


  updateProfile() {
    if (this.userId !== null) {
      this.userListService.updateUser(this.userId, this.user).subscribe(
        () => {
          this.updateSuccess = true;
          this.updateError = false;
        },
        error => {
          console.error('Error updating profile', error);
          this.updateSuccess = false;
          this.updateError = true;
        }
      );
    } else {
      alert('User ID not found. Please log in again.');
    }
  }
}
