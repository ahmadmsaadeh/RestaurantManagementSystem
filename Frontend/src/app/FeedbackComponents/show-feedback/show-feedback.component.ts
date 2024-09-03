import { Component, OnInit } from '@angular/core';
import { FeedbackService } from 'src/app/services/feedback.service';


@Component({
  selector: 'app-show-feedback',
  templateUrl: './show-feedback.component.html',
  styleUrls: ['./show-feedback.component.css']
})
export class ShowFeedbackComponent implements OnInit {
  feedbacks: any[] = [];

  constructor(private feedbackService: FeedbackService) {}

  ngOnInit(): void {
    this.loadFeedbacks();
  }

  loadFeedbacks(): void {
    this.feedbackService.getFeedbacks().subscribe((data: any[]) => {
      this.feedbacks = data;
    });
  }
}
