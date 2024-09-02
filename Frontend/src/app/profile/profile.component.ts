import { Component, OnInit } from '@angular/core';
import {UserlistService} from "../userlist/service/userlist.service";


@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
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

  constructor(private userListService: UserlistService) {}

  ngOnInit(): void {
    this.getUserProfile();
  }
  updateProfile() {
    this.userListService.updateUser(this.user.user_id, this.user).subscribe(
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
  }

  getUserProfile(): void {
    this.userListService.getUserById(1).subscribe(
      (data: any) => {
        this.user = data;
        console.log('User ID:', this.user.user_id);
        console.log('User Type:', this.user.role_id);
        console.log('User email:', this.user.email);
      },
      (error: any) => {
        console.error('Error fetching user profile:', error);
      }
    );
  }
}
