import {Component, Input} from '@angular/core';

@Component({
  selector: 'app-fullscreen-background',
  templateUrl: './fullscreen-background.component.html',
  styleUrls: ['./fullscreen-background.component.css']
})
export class FullscreenBackgroundComponent {
  @Input() imageUrl: string = '';
}
