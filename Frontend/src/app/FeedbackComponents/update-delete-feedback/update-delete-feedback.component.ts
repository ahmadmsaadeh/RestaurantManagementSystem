import { Component, OnInit } from '@angular/core';
import { FeedbackService } from 'src/app/services/feedback.service';
import { LoginService } from "../../login/service/LoginService";
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';

@Component({
  selector: 'app-update-delete-feedback',
  templateUrl: './update-delete-feedback.component.html',
  styleUrls: ['./update-delete-feedback.component.css']
})
export class UpdateDeleteFeedbackComponent implements OnInit {
  feedbacks: any[] = [];
  selectedFeedback: any = null; 

  constructor(
    private feedbackService: FeedbackService, 
    private loginService: LoginService,
    private modalService: NgbModal 
  ) {}

  ngOnInit(): void {
    this.loadUserFeedbacks();
  }

  loadUserFeedbacks(): void {
    const userId = this.loginService.getUserId();
  
    if (userId !== null) {
      this.feedbackService.getFeedbacksByUser(userId).subscribe((data: any[]) => {
        this.feedbacks = data;
      });
    } else {
      console.error('User ID is null. Cannot load feedbacks.');
    }
  }

  deleteFeedback(id: number): void {
    console.log(id);
    if (confirm('Are you sure you want to delete this feedback?')) {
      this.feedbackService.deleteFeedback(id).subscribe(() => {
        this.feedbacks = this.feedbacks.filter(feedback => feedback.feedback_id !== id);
      });
    }
  }

  openUpdateModal(feedback: any, content: any): void {
    console.log(feedback);
    this.selectedFeedback = { ...feedback }; 
    this.modalService.open(content, { ariaLabelledBy: 'modal-basic-title' }).result.then((result) => {
      if (result === 'save') {
        this.updateFeedback(this.selectedFeedback);
      }
    });
  }

  updateFeedback(feedback: any): void {
    if (feedback.rating < 1 || feedback.rating > 5) {
      alert('Rating must be between 1 and 5.');
      return;
    }
    this.feedbackService.updateFeedback(feedback.feedback_id, feedback).subscribe(updatedFeedback => {
      const index = this.feedbacks.findIndex(f => f.feedback_id === updatedFeedback.feedback_id);
      if (index !== -1) {
        this.feedbacks[index] = updatedFeedback; 
      }
    });
  }
}
