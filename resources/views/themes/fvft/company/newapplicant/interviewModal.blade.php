  <!-- Modal -->
  <div class="modal fade" id="interviewModal" tabindex="-1" role="dialog" aria-labelledby="interviewModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="interviewModalLabel">Schedule Interview</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form action="#" method="#" id="scheduleInterViewForm">
                      @csrf
                      <div class="form-group">
                          <div class="row">
                              <div class="col-md-4">
                                  <label class="form-label">Interview Date</label>
                              </div>
                              <div class="col-md-8">
                                  <input type="date" class="form-control" name="interview_date">
                                  <span class="require text-danger interview_date"></span>
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="row">
                              <div class="col-md-4">
                                  <label class="form-label">Interview Time</label>
                              </div>
                              <div class="col-md-8">
                                  <input type="time" class="form-control" name="interview_time">
                                  <span class="require text-danger interview_time"></span>
                              </div>
                          </div>
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" id="saveScheduleInterview"
                      onclick="scheduleInterview();">Schedule Interview</button>
              </div>
          </div>
      </div>
  </div>
