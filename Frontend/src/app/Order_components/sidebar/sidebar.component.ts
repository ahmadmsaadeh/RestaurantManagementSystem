import {AfterViewInit, Component} from '@angular/core';
import {RouterLink} from "@angular/router";

@Component({
  selector: 'app-sidebar',
  templateUrl: './sidebar.component.html',
  standalone: true,
  imports: [
    RouterLink
  ],
  styleUrls: ['./sidebar.component.css']
})
export class SidebarComponent implements AfterViewInit {
  ngAfterViewInit(): void {
    const hamBurger = document.querySelector(".toggle-btn") as HTMLElement;
    hamBurger?.addEventListener("click", () => {
      const sidebar = document.querySelector("#sidebar") as HTMLElement;
      sidebar?.classList.toggle("expand");
    });
  }
}
