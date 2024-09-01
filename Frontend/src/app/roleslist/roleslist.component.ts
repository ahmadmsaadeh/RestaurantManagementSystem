import { Component, OnInit } from '@angular/core';
import { RolelistService } from './services/rolelist.service';

@Component({
  selector: 'app-roleslist',
  templateUrl: './roleslist.component.html',
  styleUrls: ['./roleslist.component.css']
})
export class RoleslistComponent implements OnInit {

  roles: any[] = [];
  filteredRoles: any[] = [];
  usersByRole: { [key: number]: any[] } = {};
  selectedUser: any = null;
  searchQuery: string = '';
  showAddRoleDialog: boolean = false;


  newRole = {
    role_name: '',
    description: ''
  };

  constructor(private rolelistService: RolelistService) {}

  ngOnInit() {
    this.showAllRoles();
  }

  showAllRoles() {
    this.rolelistService.getRoleList().subscribe(
      (roles: any[]) => {
        this.roles = roles;
        this.filteredRoles = roles; // Initialize filteredRoles with all roles
        this.roles.forEach(role => {
          this.getUsersForRole(role.role_id);
        });
      },
      error => {
        console.error('Error fetching roles', error);
        alert('Error fetching roles. Please try again later.');
      }
    );
  }

  getUsersForRole(roleId: number) {
    this.rolelistService.getUsersForRole(roleId).subscribe(
      (response: any) => {
        if (response && Array.isArray(response.users)) {
          this.usersByRole[roleId] = response.users;
        } else {
          console.error('Invalid response structure for users', response);
        }
      },
      error => {
        console.error('Error fetching users for role', error);
        alert('Error fetching users for this role. Please try again later.');
      }
    );
  }

  filterRoles() {
    if (this.searchQuery) {
      this.filteredRoles = this.roles.filter(role =>
        role.role_name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
        role.description.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    } else {
      this.filteredRoles = this.roles;
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

  updateRole(roleId: number, roleName: string, description: string) {
    const updatedRoleData = {
      role_name: roleName,
      description: description
    };

    this.rolelistService.updaterole(roleId, updatedRoleData).subscribe(
      response => {
        console.log('Role updated successfully', response);
        alert('Role updated successfully.');
        this.showAllRoles(); // Refresh roles list
      },
      error => {
        console.error('Error updating role', error);
        alert('Error updating role. Please try again later.');
      }
    );
  }

  deleteRole(roleId: number) {
    if (confirm('Are you sure you want to delete this role?')) {
      this.rolelistService.deleterole(roleId).subscribe(
        response => {
          console.log('Role deleted successfully', response);
          alert('Role deleted successfully.');
          this.showAllRoles(); // Refresh roles list
        },
        error => {
          console.error('Error deleting role', error);
          alert('Error deleting role. Please try again later.');
        }
      );
    }
  }

  openAddRoleDialog() {
    this.showAddRoleDialog = true;
  }

  closeAddRoleDialog() {
    this.showAddRoleDialog = false;
  }

  addRole() {
    this.rolelistService.addRole(this.newRole).subscribe(
      response => {
        console.log('Role added successfully', response);
        alert('Role added successfully.');
        this.showAllRoles();
        this.newRole = { role_name: '', description: '' };
        this.closeAddRoleDialog();
      },
      error => {
        console.error('Error adding role', error);
        alert('Error adding role. Please try again later.');
      }
    );
  }

}
