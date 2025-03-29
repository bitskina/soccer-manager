<?php

namespace App\Http\Requests\PlayerTransfers;

use App\Models\PlayerTransfer;
use Closure;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePlayerTransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'team_id' => 'required|integer',
            'player_id' => [
                'required',
                'integer',
                Rule::exists('players', 'id')->where(function (Builder $query) {
                    $query->where('team_id', $this->input('team_id'));
                }),
                function (string $attribute, mixed $value, Closure $fail) {
                    if (PlayerTransfer::query()->active()->where('player_id', $value)->exists()) {
                        $fail(__('validation.player_already_on_transfer'));
                    }
                },
            ],
            'sell_price' => 'required|numeric|gt:0',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['team_id' => $this->user()?->team?->id]);
    }
}
