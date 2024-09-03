import { Component, OnInit } from '@angular/core';
import {UserlistService} from "./service/userlist.service";
import {FormsModule} from "@angular/forms";
import {NgForOf, NgIf} from "@angular/common";

@Component({
  selector: 'app-userlist',
  templateUrl: './userlist.component.html',
  standalone: true,
  imports: [
    FormsModule,
    NgIf,
    NgForOf
  ],
  styleUrls: ['./userlist.component.css']
})
export class UserlistComponent implements OnInit {

  users: any[] = [];
  filteredUsers: any[] = [];
  selectedUser: any = null;
  searchQuery: string = '';
  showAddUserDialog: boolean = false;
  roles: { [key: number]: string } = {};
  role_name : string = '';

  newUser = {
    username: '',
    email: '',
    firstname: '',
    lastname: '',
    phonenumber: ''
  };

  constructor(private userListService: UserlistService) {}

  ngOnInit() {
    this.loadUsers();
  }

  loadUsers() {
    this.userListService.getUserList().subscribe(
      (users: any[]) => {
        this.users = users;
        this.filteredUsers = users;
        this.fetchRoleNames(users);
      },
      error => {
        console.error('Error fetching users', error);
        alert('Error fetching users. Please try again later.');
      }
    );
  }

  filterUsers() {
    if (this.searchQuery) {
      this.filteredUsers = this.users.filter(user =>
        user.username.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
        user.email.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
        user.firstname.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
        user.lastname.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
        user.phonenumber.includes(this.searchQuery)
      );
    } else {
      this.filteredUsers = this.users;
    }
  }

  openAddUserDialog() {
    this.showAddUserDialog = true;
  }

  closeAddUserDialog() {
    this.showAddUserDialog = false;
  }

  addUser() {
    if (!this.newUser.username || !this.newUser.email || !this.newUser.firstname || !this.newUser.lastname || !this.newUser.phonenumber) {
      return;
    }
    this.userListService.addUser(this.newUser).subscribe(
      user => {
        this.users.push(user);
        this.filteredUsers.push(user);
        this.closeAddUserDialog();
        this.resetNewUser();
      },
      error => {
        console.error('Error adding user', error);
        alert('Error adding user. Please try again later.');
      }
    );
  }

  updateUser(userId: number, updatedUser: { username: string; email: string; firstname: string; lastname: string; phonenumber: string; }) {
    this.userListService.updateUser(userId, updatedUser).subscribe(
      () => {
        this.loadUsers();
        alert('Updated Done!')
      },
      error => {
        console.error('Error updating user', error);
        alert('Error updating user. Please try again later.');
      }
    );
  }

  deleteUser(userId: number) {
    if (confirm('Are you sure you want to delete this user?')) {
      this.userListService.deleteUser(userId).subscribe(
        () => {
          this.users = this.users.filter(user => user.user_id !== userId);
          this.filteredUsers = this.filteredUsers.filter(user => user.user_id !== userId);
          alert('You deleted the user successfully!')
        },
        error => {
          console.error('Error deleting user', error);
          alert('Error deleting user. Please try again later.');
        }
      );
    }
  }

  openUserModal(user: any) {
    this.selectedUser = user;
    document.getElementById('userModal')!.style.display = 'block';
  }

  closeUserModal() {
    this.selectedUser = null;
    document.getElementById('userModal')!.style.display = 'none';
  }

  fetchRoleNames(users: any[]) {
    const roleIds = Array.from(new Set(users.map(user => user.role_id)));
    roleIds.forEach(role_id => {
      this.userListService.getRoleName(role_id).subscribe(
        role_name => this.roles[role_id] = role_name,
        error => console.error(`Error fetching role name for role_id ${role_id}:`, error)
      );

    });
  }

  private resetNewUser() {
    this.newUser = {
      username: '',
      email: '',
      firstname: '',
      lastname: '',
      phonenumber: ''
    };
  }

}
