<div class="form-group form-check">
    <input class="form-check-input" type="checkbox" id="checkboxActive" value="1"
           name="is_active"  {{ (old('is_active') || (!old('_token') && ($default ?? ''))) ? 'checked' : '' }}>
    <label class="form-check-label" for="checkboxActive">Опубликовать</label>
</div>
