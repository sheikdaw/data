<div>
    <input wire:model="searchInput" type="text" placeholder="Search..." wire:keyup="updateData">
    <select wire:model="selectColumn" wire:change="updateData">
        <option value="assessment">Assessment</option>
        <option value="ward">Ward</option>
        <!-- Add other options -->
    </select>
    <div>
        <table class="table table-responsive shadow card table-hover">
            <thead>
                <tr>
                    <th>Assessment</th>
                    <th>Ward</th>
                    <!-- Other table headers -->
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                    <tr>
                        <td>{{ $item->assessment }}</td>
                        <td>{{ $item->ward }}</td>
                        <!-- Display other columns accordingly -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    
        <!-- Display pagination links -->
        <div class="d-flex justify-content-center mt-3">
            {{ $data->render() }}
        </div>
    </div>
</div>
