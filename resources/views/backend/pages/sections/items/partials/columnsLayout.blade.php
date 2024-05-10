<div class="col-md-4 mb-3">
                                    <label for="divider" class="form-label">{{ localize('Divisore tra colonne') }}</label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input wh-x2" id="divider" name="settings[divider]" {{ $section->settings['divider'] ?? false ? 'checked' : '' }}>
                                    </div>

                                </div>
                                @php

                                $selectedLayout = $section->settings['columnLayout'] ?? '';
                                @endphp
                                <div class="col-mb-4 mb-3">
                                    <label for="columnLayout">Disposizione colonne</label>
                                    <select class="form-control" id="columnLayout" name="settings[columnLayout]">
                                        <option value="12" {{ $selectedLayout == '12' ? 'selected' : '' }}>{{ '1 colonna (12)' }}</option>
                                        <option value="6-6" {{ $selectedLayout == '6-6' ? 'selected' : '' }}>{{ '2 colonne uguali (6-6)' }}</option>
                                        <option value="7-5" {{ $selectedLayout == '7-5' ? 'selected' : '' }}>{{ '2 colonne (7-5)' }}</option>
                                        <option value="5-7" {{ $selectedLayout == '5-7' ? 'selected' : '' }}>{{ '2 colonne (5-7)' }}</option>
                                        <option value="8-4" {{ $selectedLayout == '8-4' ? 'selected' : '' }}>{{ '2 colonne (8-4)' }}</option>
                                        <option value="4-8" {{ $selectedLayout == '4-8' ? 'selected' : '' }}>{{ '2 colonne (4-8)' }}</option>
                                        <option value="4-4-4" {{ $selectedLayout == '4-4-4' ? 'selected' : '' }}>{{ '3 colonne (4-4-4)' }}</option>
                                        <option value="3-3-3-3" {{ $selectedLayout == '3-3-3-3' ? 'selected' : '' }}>{{ '4 colonne (3-3-3-3)' }}</option>
                                        <option value="6-3-3" {{ $selectedLayout == '6-3-3' ? 'selected' : '' }}>{{ '3 colonne (6-3-3)' }}</option>
                                        <option value="3-6-3" {{ $selectedLayout == '3-6-3' ? 'selected' : '' }}>{{ '3 colonne (3-6-3)' }}</option>
                                        <option value="3-3-6" {{ $selectedLayout == '3-3-6' ? 'selected' : '' }}>{{ '3 colonne (3-3-6)' }}</option>
                                        <option value="2-8-2" {{ $selectedLayout == '2-8-2' ? 'selected' : '' }}>{{ '3 colonne (2-8-2)' }}</option>
                                        <option value="2-2-2-6" {{ $selectedLayout == '2-2-2-6' ? 'selected' : '' }}>{{ '4 colonne (2-2-2-6)' }}</option>
                                        <option value="2-2-6-2" {{ $selectedLayout == '2-2-6-2' ? 'selected' : '' }}>{{ '4 colonne (2-2-6-2)' }}</option>
                                        <option value="2-6-2-2" {{ $selectedLayout == '2-6-2-2' ? 'selected' : '' }}>{{ '4 colonne (2-6-2-2)' }}</option>
                                        <option value="6-2-2-2" {{ $selectedLayout == '6-2-2-2' ? 'selected' : '' }}>{{ '4 colonne (6-2-2-2)' }}</option>
                                    </select>


                                    <div id="columnDisplay" style="width: 100%; margin-top: 20px; clear: both;"></div>

                                </div>