<!-- Modal -->
<div class="modal fade" id="newSkillModal" tabindex="-1" role="dialog" aria-labelledby="newSkillModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSkillModalLabel">{{ __('Add New Skill') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.skill.ajaxAddSkill') }}" id="newSkillForm" method="POST">
                    @csrf
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name">{{ __('Skill Title') }}&nbsp;<span class="req">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="title" class="form-control">
                                    <div class="title require"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-gray" data-dismiss="modal">{{ __('Close') }}</button>
                <button type="button" id="addNewSkill" class="btn btn-primary">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</div>
